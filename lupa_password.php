<?php

session_start();
include "fungsi.php";

// $mail->SMTPOptions = array(
//     'ssl' => array(
//         'verify_peer' => false,
//         'verify_peer_name' => false,
//         'allow_self_signed' => true
//     )
// );

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// autetikasi Login
if (!empty($_SESSION['usr']) || $_SESSION['usr'] != '' || isset($_SESSION['usr'])) {
    header("Location: modul/");
}

if (isset($_POST['kirim'])) {
    $email = $_POST['email'];

    $queryCekEmail = mysqli_query($konek, "SELECT * FROM pic WHERE email = '$email'");
    $totalCekEmail = mysqli_num_rows($queryCekEmail);
    $dataCekEmail = mysqli_fetch_assoc($queryCekEmail);

    if ($totalCekEmail == 0) {
        // ALERT KALO EMAILNYA NGGA KEDAFTAR
        echo "<script>window.alert('Email tidak terdaftar, silahkan hubungi Administrator!');
					location='lupa_password.php'
				</script>";
    } else {
        // ALERT KLO USERNAME NYA NGGA AKTIF
        if ($dataCekEmail['user_aktif'] == "0") {
            echo "<script>window.alert('Email tidak aktif untuk masuk ke sistem, silahkan hubungi Administrator!');
                        location='lupa_password.php'
                    </script>";
        } else {
            // SUKSES RESET PASSWORD, DAN NGIRIM KE EMAIL
            $id_pic = $dataCekEmail['id_pic'];
            $karakter = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
            $acak = substr(str_shuffle($karakter), 0, 7);
            $pass = md5($acak);

            require_once "assets/plugins/PHPMailer/PHPMailer.php";
            require_once "assets/plugins/PHPMailer/Exception.php";
            require_once "assets/plugins/PHPMailer/OAuth.php";
            require_once "assets/plugins/PHPMailer/POP3.php";
            require_once "assets/plugins/PHPMailer/SMTP.php";

            $mail = new PHPMailer;

            //Enable SMTP debugging. 
            // $mail->SMTPDebug = 3;    //NGILANGIN DEBUG KEKNYA                           
            //Set PHPMailer to use SMTP.
            $mail->isSMTP();
            //Set SMTP host name                          
            $mail->Host = "tls://smtp.gmail.com"; //host mail server
            //Set this to true if SMTP host requires authentication to send email
            $mail->SMTPAuth = true;
            //Provide username and password     
            $mail->Username = "system.ekanuri@gmail.com";   //nama-email smtp          
            $mail->Password = dekripsi("Vm14U1QyTXlWblJWYTJoWFlteEtUMVpyVlhkbFJsSjFZMGhLVVZWVU1Eaz0=");           //password email smtp
            //If SMTP requires TLS encryption then set it
            $mail->SMTPSecure = "tls";
            //Set TCP port to connect to 
            $mail->Port = 587;

            $mail->From = "system.ekanuri@gmail.com"; //email pengirim
            $mail->FromName = "System Ekanuri (No Reply)"; //nama pengirim

            $mail->addAddress($dataCekEmail['email'], $dataCekEmail['nm_pic']); //email penerima

            $mail->isHTML(true);

            $mail->Subject = "Reset Password " . $dataCekEmail['nm_pic']; //subject
            $mail->Body = "Yth. " . $dataCekEmail['nm_pic'] . ",<br><br>
                            Anda telah melakukan reset password untuk masuk ke Monitoring Server<br>
                            Berikut password yang sudah dirubah untuk masuk ke sistem Monitoring Server.<br><br>

                            <b>$acak</b><br><br>

                            Jika anda tidak merasa melakukan permintaan reset password, mohon untuk abaikan Email ini.<br>
                            Atas perhatiannya kami ucapkan terima kasih.";        // isi pesan
            $mail->AltBody = "PHP mailer"; //body email (optional)

            if (!$mail->send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                // UPDATE PASSWORD ACAK
                $update = mysqli_query($konek, "UPDATE pic SET password = '$pass' WHERE id_pic = '$id_pic'");

                // echo "Message has been sent successfully";
                if ($update) {
                    echo "<script>window.alert('Password berhasil dirubah, silahkan cek email anda.');
                                location='login.php'
                            </script>";
                }
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <link href="assets/img/gambar/logo-small.svg" rel="shortcut icon">
    <title>Lupa Password - Monitoring Server</title>
    <link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/plugins/font-family/fonts.googleapis.css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
    <link rel="stylesheet" href="assets/plugins/animate.css/animate.min.css">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext"> -->

    <script src="assets/js/require.min.js"></script>
    <!-- Sweet alert -->
    <!-- <script src="assets/plugins/sweetalert2/dist/sweetalert2.all.min.js"></script> -->
    <script>
        requirejs.config({
            baseUrl: '.'
        });
    </script>
    <!-- Dashboard Core -->
    <link href="assets/css/dashboard.css" rel="stylesheet">
    <script src="assets/js/dashboard.js"></script>
    <!-- c3.js Charts Plugin -->
    <link href="assets/plugins/charts-c3/plugin.css" rel="stylesheet">
    <script src="assets/plugins/charts-c3/plugin.js"></script>
    <!-- Google Maps Plugin -->
    <link href="assets/plugins/maps-google/plugin.css" rel="stylesheet">
    <script src="assets/plugins/maps-google/plugin.js"></script>
    <!-- Input Mask Plugin -->
    <script src="assets/plugins/input-mask/plugin.js"></script>

</head>

<body class="">
    <div class="page">
        <div class="page-single">
            <div class="container">
                <div class="row">
                    <div class="col col-login mx-auto">
                        <div class="text-center mb-6">
                            <img src="assets/brand/tabler.svg" class="h-6" alt="">
                        </div>
                        <form class="card animate__animated animate__flipInX" action="" method="POST">
                            <div class="card-body p-6">
                                <div class="card-title">Lupa Password</div>
                                <p class="text-muted mb-4">Masukkan alamat email Anda, kata sandi akan diatur ulang dan dikirim ke email Anda.</p>
                                <div class="form-group">
                                    <label class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email" name="email" required>
                                </div>
                                <div class="form-footer">
                                    <button type="submit" class="btn btn-primary btn-block w-100 " name="kirim">Kirim</button>
                                </div>
                            </div>
                        </form>
                        <div class="text-center text-muted">
                            Udah inget? <a href="login.php">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>