<?php
session_start();
include "fungsi.php";

// autetikasi Login
if (!empty($_SESSION['usr']) || $_SESSION['usr'] != '' || isset($_SESSION['usr'])) {
    header("Location: modul/");
}

if (isset($_POST['login'])) {
    $usrnm = $_POST['usrnm'];
    $pswrd = md5($_POST['pswrd']);

    $login = mysqli_query($konek, "SELECT * FROM pic WHERE email = '$usrnm' AND password = '$pswrd' AND user_aktif = '1'");
    $total = mysqli_num_rows($login);

    if ($total > 0) {
        $data = mysqli_fetch_assoc($login);
        $_SESSION['id'] = $data['id_pic'];
        $_SESSION['usr'] = $data['email'];
        $_SESSION['nm'] = $data['nm_pic'];
        $_SESSION['tlgrm'] = $data['chat_id'];
        $_SESSION['telp'] = $data['no_telp'];
        // buat ingat saya
        if (isset($_POST['remember'])) {
            setcookie('usr', enkripsi($_POST['usrnm']), time() + 259200);
            setcookie('pwd', enkripsi($_POST['pswrd']), time() + 259200);
        } else {
            setcookie('usr', enkripsi($_POST['usrnm']), time() - 259200);
            setcookie('pwd', enkripsi($_POST['pswrd']), time() - 259200);
        }
        header('Location: modul/');
    } else {
        echo "<script>window.alert('Username atau password salah!');
					location='login.php'
				</script>";
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
    <title>Login - Monitoring Server</title>
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
                        <form class="card animate__animated animate__fadeInDown" action="" method="POST">
                            <div class="card-body p-6">
                                <div class="card-title">Login Monitoring Server</div>
                                <div class="form-group">
                                    <label class="form-label">Username</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email" name="usrnm" value="<?= (isset($_COOKIE['usr']) && isset($_COOKIE['pwd'])) ? dekripsi($_COOKIE['usr']) : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">
                                        Password
                                        <a href="lupa_password.php" class="float-right small">Lupa password</a>
                                    </label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="pswrd" value="<?= (isset($_COOKIE['usr']) && isset($_COOKIE['pwd'])) ? dekripsi($_COOKIE['pwd']) : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="remember" <?= (isset($_COOKIE['usr']) && isset($_COOKIE['pwd'])) ? 'checked' : ''; ?>>
                                        <span class="custom-control-label" title="Ingat saya dalam 3 hari">Ingat saya</span>
                                    </label>
                                </div>
                                <div class="form-footer">
                                    <button type="submit" class="btn btn-primary btn-block" name="login">Login</button>
                                </div>
                            </div>
                        </form>
                        <!-- <div class="text-center text-muted">
                            Don't have account yet? <a href="register.html">Sign up</a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>