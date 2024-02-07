<?php

use Spipu\Html2Pdf\Tag\Html\Label;

session_start();
include "../fungsi.php";

// autetikasi Login
if (empty($_SESSION['usr']) || $_SESSION['usr'] == '' || !isset($_SESSION['usr'])) {
	header("Location: ../");
}

// JIKA NGGA ADA KONEKSI INTERNET KASIH PESAN
if (!isInternetConnected()) {
	setcookie('pesan', 'Koneksi internet sedang tidak stabil.', time() + 259200);
	setcookie('warna', 'default', time() + 259200);
} else {
	setcookie('pesan', 'Koneksi internet sedang tidak stabil.', time() - 259200);
	setcookie('warna', 'default', time() - 259200);
}

// ngambil data user
$id_pic = $_SESSION['id'];
$queryUser = mysqli_query($konek, "SELECT * FROM pic WHERE id_pic = '$id_pic'");
$dataUser = mysqli_fetch_assoc($queryUser);
$mon_aktif = $dataUser['monitoring_aktif'];

// aksi buat logout
if (isset($_GET['keluar']) && $_GET['keluar'] == enkripsi("true")) {
	unset($_SESSION['id']);
	unset($_SESSION['usr']);
	unset($_SESSION['nm']);
	unset($_SESSION['tlgrm']);
	unset($_SESSION['telp']);
	session_destroy();
	header("Location: ../");
	exit;
}

// RUBAH DATA PROFIL
if (isset($_POST['rubah_profil'])) {
	$id = $_POST['id'];
	$nama = $_POST['nama'];
	$username = $_POST['username'];
	$telepon = $_POST['telepon'];
	$chat_id = "706694762";
	// $monitoring_aktif = isset($_POST['monitoring_aktif']) ? '1' : '0';
	$posisi = $_POST['posisi'];

	// cek email apakah sudah ada
	$cek_email = mysqli_query($konek, "SELECT email FROM pic WHERE email = '$username'");
	$total_cek = mysqli_num_rows($cek_email);

	if ($total_cek > 0 && $_SESSION['usr'] != $username) {
		echo "<script>alert('Gagal merubah data, Email sudah ada sebelumnya!');</script>";
	} else {
		$cek_foto = $_FILES['foto']['name'];
		if ($cek_foto == "") {
			$foto = $_POST['foto_lama'];
		} else {
			$del_foto = $_POST['foto_lama'];
			unlink("../assets/img/foto/$del_foto");
			$foto_temp = $_FILES['foto']['name'];
			$path = $_FILES['foto']['tmp_name'];
			$ekstensi = pathinfo($foto_temp, PATHINFO_EXTENSION);
			$foto = $username . "." . $ekstensi;
			move_uploaded_file($path, "../assets/img/foto/$foto");
		}

		if ($_POST['password'] == "") {
			$password = "";
			$url = $_POST['pg'] != '' ? 'index.php?pg=' . $_POST['pg'] : '.';
		} else {
			$password = "password = '" . md5($_POST['password']) . "',";
			$url = "index.php?keluar=" . enkripsi("true");
		}

		$update = mysqli_query($konek, "UPDATE pic SET nm_pic = '$nama',
												chat_id = '$chat_id',
												email = '$username', $password
												no_telp = '$telepon',
												posisi = '$posisi',
												foto = '$foto'
										WHERE id_pic = '$id'
    
                    ");

		if ($update) {
			header('Location: ' . $url . '');
		} else {
			echo die(mysqli_error($konek));
		}
	}
}

// TOTAL SERVER
$queryServer = mysqli_query($konek, "SELECT COUNT(id_ip) AS jumlah FROM data_ip");
$dataServer = mysqli_fetch_assoc($queryServer);

// TOTAL PIC
$queryPIC = mysqli_query($konek, "SELECT COUNT(id_pic) AS jumlah FROM pic");
$dataPIC = mysqli_fetch_assoc($queryPIC);

// TOTAL MONITORING
$queryMonitoring = mysqli_query($konek, "SELECT COUNT(id_rto) as jumlah FROM monitoring_rto WHERE kirim_telegram IS NOT NULL");
$dataMonitoring = mysqli_fetch_assoc($queryMonitoring);

$persen = $dataMonitoring['jumlah'] * $dataServer['jumlah'] / 100;

// TOTAL GRAFIK
$queryGrafik = mysqli_query($konek, "SELECT  CONCAT(DATE_FORMAT(tanggal_rto, '%b'), ' ', YEAR(tanggal_rto)) AS bulan,
										COUNT(CASE WHEN DAY(tanggal_rto) = '1' THEN tanggal_rto END) AS tgl_1,
										COUNT(CASE WHEN DAY(tanggal_rto) = '2' THEN tanggal_rto END) AS tgl_2,
										COUNT(CASE WHEN DAY(tanggal_rto) = '3' THEN tanggal_rto END) AS tgl_3,
										COUNT(CASE WHEN DAY(tanggal_rto) = '4' THEN tanggal_rto END) AS tgl_4,
										COUNT(CASE WHEN DAY(tanggal_rto) = '5' THEN tanggal_rto END) AS tgl_5,
										COUNT(CASE WHEN DAY(tanggal_rto) = '6' THEN tanggal_rto END) AS tgl_6,
										COUNT(CASE WHEN DAY(tanggal_rto) = '7' THEN tanggal_rto END) AS tgl_7,
										COUNT(CASE WHEN DAY(tanggal_rto) = '8' THEN tanggal_rto END) AS tgl_8,
										COUNT(CASE WHEN DAY(tanggal_rto) = '9' THEN tanggal_rto END) AS tgl_9,
										COUNT(CASE WHEN DAY(tanggal_rto) = '10' THEN tanggal_rto END) AS tgl_10,
										COUNT(CASE WHEN DAY(tanggal_rto) = '11' THEN tanggal_rto END) AS tgl_11,
										COUNT(CASE WHEN DAY(tanggal_rto) = '12' THEN tanggal_rto END) AS tgl_12,
										COUNT(CASE WHEN DAY(tanggal_rto) = '13' THEN tanggal_rto END) AS tgl_13,
										COUNT(CASE WHEN DAY(tanggal_rto) = '14' THEN tanggal_rto END) AS tgl_14,
										COUNT(CASE WHEN DAY(tanggal_rto) = '15' THEN tanggal_rto END) AS tgl_15,
										COUNT(CASE WHEN DAY(tanggal_rto) = '16' THEN tanggal_rto END) AS tgl_16,
										COUNT(CASE WHEN DAY(tanggal_rto) = '17' THEN tanggal_rto END) AS tgl_17,
										COUNT(CASE WHEN DAY(tanggal_rto) = '18' THEN tanggal_rto END) AS tgl_18,
										COUNT(CASE WHEN DAY(tanggal_rto) = '19' THEN tanggal_rto END) AS tgl_19,
										COUNT(CASE WHEN DAY(tanggal_rto) = '20' THEN tanggal_rto END) AS tgl_20,
										COUNT(CASE WHEN DAY(tanggal_rto) = '21' THEN tanggal_rto END) AS tgl_21,
										COUNT(CASE WHEN DAY(tanggal_rto) = '22' THEN tanggal_rto END) AS tgl_22,
										COUNT(CASE WHEN DAY(tanggal_rto) = '23' THEN tanggal_rto END) AS tgl_23,
										COUNT(CASE WHEN DAY(tanggal_rto) = '24' THEN tanggal_rto END) AS tgl_24,
										COUNT(CASE WHEN DAY(tanggal_rto) = '25' THEN tanggal_rto END) AS tgl_25,
										COUNT(CASE WHEN DAY(tanggal_rto) = '26' THEN tanggal_rto END) AS tgl_26,
										COUNT(CASE WHEN DAY(tanggal_rto) = '27' THEN tanggal_rto END) AS tgl_27,
										COUNT(CASE WHEN DAY(tanggal_rto) = '28' THEN tanggal_rto END) AS tgl_28,
										COUNT(CASE WHEN DAY(tanggal_rto) = '29' THEN tanggal_rto END) AS tgl_29,
										COUNT(CASE WHEN DAY(tanggal_rto) = '30' THEN tanggal_rto END) AS tgl_30,
										COUNT(CASE WHEN DAY(tanggal_rto) = '31' THEN tanggal_rto END) AS tgl_31
									FROM monitoring_rto
									WHERE kirim_telegram IS NOT NULL
									GROUP BY CONCAT(DATE_FORMAT(tanggal_rto, '%b'), ' ', YEAR(tanggal_rto))
									-- ORDER BY tanggal_rto ASC
									LIMIT 12
					");

// QUERY TABEL TRAFIC
$queryJumlah = mysqli_query($konek, "SELECT id_ip, kd_ip, ip_address, nm_pic, foto, COUNT(ip_id) AS total
										FROM monitoring_rto
										RIGHT JOIN data_ip
											ON id_ip = ip_id
										JOIN pic
											ON id_pic = pic_id
										WHERE kirim_telegram IS NOT NULL
										GROUP BY id_ip -- , kd_ip, ip_address, nm_pic
						");

// QUERY CHART TOTAL
$queryChartTotal = mysqli_query($konek, "SELECT id_ip, kd_ip, ip_address, nm_pic, foto, COUNT(ip_id) AS total
											FROM monitoring_rto
											RIGHT JOIN data_ip
												ON id_ip = ip_id
											JOIN pic
												ON id_pic = pic_id
											WHERE kirim_telegram IS NOT NULL
											GROUP BY id_ip -- , kd_ip, ip_address, nm_pic
						");

// QUERY CHART IP
$queryIPTotal = mysqli_query($konek, "SELECT id_ip, kd_ip, ip_address, nm_pic, foto, COUNT(ip_id) AS total
										FROM monitoring_rto
										RIGHT JOIN data_ip
											ON id_ip = ip_id
										JOIN pic
											ON id_pic = pic_id
										WHERE kirim_telegram IS NOT NULL
										GROUP BY id_ip -- , kd_ip, ip_address, nm_pic
						");


// buat monitoring jaringan server
if ($mon_aktif == "1") {
	include "../monitoring_manual.php";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Monitoring Server</title>
	<!-- CSS files -->
	<link href="../assets/css/tabler.min.css" rel="stylesheet">
	<link href="../assets/css/tabler-flags.min.css" rel="stylesheet">
	<link href="../assets/css/tabler-payments.min.css" rel="stylesheet">
	<link href="../assets/css/tabler-vendors.min.css" rel="stylesheet">
	<link href="../assets/css/demo.min.css" rel="stylesheet">
	<link href="../assets/img/gambar/logo-small.svg" rel="shortcut icon">

	<!-- javascript buat jam -->
	<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
</head>

<body class="antialiased">
	<div class="wrapper">
		<header class="navbar navbar-expand-md navbar-light d-print-none">
			<div class="container-xxl">
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
					<span class="navbar-toggler-icon"></span>
				</button>
				<h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
					<a href=".">
						<img src="../assets/img/gambar/logo-small.svg" width="110" height="32" alt="Monitoring Server" class="navbar-brand-image" />
					</a>
					<label style="font-size: 12px;" class="custom-control-label">&nbsp;Monitoring<br>&nbsp;Server</label>
				</h1>
				<div class="navbar-nav flex-row order-md-last">
					<div class="nav-item dropdown d-none d-md-flex me-3" data-bs-toggle="tooltip" title="Monitoring Manual">
						<?php if ($mon_aktif == "1") { ?>
							<a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
								<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-desktop" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
									<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
									<rect x="3" y="4" width="18" height="12" rx="1"></rect>
									<line x1="7" y1="20" x2="17" y2="20"></line>
									<line x1="9" y1="16" x2="9" y2="20"></line>
									<line x1="15" y1="16" x2="15" y2="20"></line>
								</svg>
								<span class="badge bg-success"></span>
							</a>
							<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
								<a href="monitoring_status.php?id=<?= enkripsi($id_pic); ?>&status=<?= enkripsi("1") ?>" class="dropdown-item active"><span class="badge bg-success me-1"></span>Active</a>
								<a href="monitoring_status.php?id=<?= enkripsi($id_pic); ?>&status=<?= enkripsi("0") ?>" class="dropdown-item "><span class="badge bg-danger me-1"></span>Inactive</a>
							</div>
						<?php } else { ?>
							<a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
								<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-screen-share-off" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
									<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
									<path d="M21 12v3a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1v-10a1 1 0 0 1 1 -1h9"></path>
									<line x1="7" y1="20" x2="17" y2="20"></line>
									<line x1="9" y1="16" x2="9" y2="20"></line>
									<line x1="15" y1="16" x2="15" y2="20"></line>
									<path d="M17 8l4 -4m-4 0l4 4"></path>
								</svg>
								<span class="badge bg-danger"></span>
							</a>
							<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
								<a href="monitoring_status.php?id=<?= enkripsi($id_pic); ?>&status=<?= enkripsi("1") ?>" class="dropdown-item "><span class="badge bg-success me-1"></span>Active</a>
								<a href="monitoring_status.php?id=<?= enkripsi($id_pic); ?>&status=<?= enkripsi("0") ?>" class="dropdown-item active"><span class="badge bg-danger me-1"></span>Inactive</a>
							</div>
						<?php } ?>
					</div>
					<div class="nav-item dropdown">
						<a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
							<span class="avatar avatar-sm" style="background-image: url(../assets/img/foto/<?= cek_foto($dataUser['foto']); ?>)"></span>
							<div class="d-none d-xl-block ps-2">
								<div><?= $dataUser['nm_pic']; ?></div>
								<div class="mt-1 small text-muted"><?= $dataUser['email']; ?></div>
							</div>
						</a>
						<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
							<a href="" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-profile">Profile</a>
							<!-- <div class="dropdown-divider"></div> -->
							<a href="index.php?keluar=<?= enkripsi("true") ?>" class=" dropdown-item">Logout</a>
						</div>
					</div>
				</div>
			</div>
		</header>
		<div class="navbar-expand-md">
			<div class="collapse navbar-collapse" id="navbar-menu">
				<div class="navbar navbar-light">
					<div class="container-xxl">
						<ul class="navbar-nav">
							<li class="nav-item <?= !isset($_GET['pg']) ? 'active' : ''; ?> ">
								<a class="nav-link" href=".">
									<span class="nav-link-icon d-md-none d-lg-inline-block">
										<!-- Download SVG icon from http://tabler-icons.io/i/home -->
										<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
											<path stroke="none" d="M0 0h24v24H0z" fill="none" />
											<polyline points="5 12 3 12 12 3 21 12 19 12" />
											<path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
											<path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
										</svg>
									</span>
									<span class="nav-link-title">Home</span>
								</a>
							</li>
							<li class="nav-item dropdown <?= $_GET['pg'] == 'ip_domain' || $_GET['pg'] == 'pic'  ? 'active' : ''; ?>">
								<a class="nav-link dropdown-toggle" href="" data-bs-toggle="dropdown" role="button" aria-expanded="false">
									<span class="nav-link-icon d-md-none d-lg-inline-block">
										<!-- Download SVG icon from http://tabler-icons.io/i/package -->
										<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
											<path stroke="none" d="M0 0h24v24H0z" fill="none" />
											<polyline points="12 3 20 7.5 20 16.5 12 21 4 16.5 4 7.5 12 3" />
											<line x1="12" y1="12" x2="20" y2="7.5" />
											<line x1="12" y1="12" x2="12" y2="21" />
											<line x1="12" y1="12" x2="4" y2="7.5" />
											<line x1="16" y1="5.25" x2="8" y2="9.75" />
										</svg>
									</span>
									<span class="nav-link-title"> Master Data </span>
								</a>
								<div class="dropdown-menu ">
									<div class="dropdown-menu-columns">
										<div class="dropdown-menu-column">
											<a class="dropdown-item" href="index.php?pg=ip_domain">IP Address/Domain</a>
											<a class="dropdown-item" href="index.php?pg=pic">PIC</a>
										</div>
										<!-- <div class="dropdown-menu-column">
											<a class="dropdown-item" href="navigation.html">
												Navigation
											</a>
										</div> -->
									</div>
								</div>
							</li>
							<li class="nav-item dropdown <?= $_GET['pg'] == 'laporan'  ? 'active' : ''; ?>">
								<a class="nav-link dropdown-toggle" href="" data-bs-toggle="dropdown" role="button" aria-expanded="false">
									<span class="nav-link-icon d-md-none d-lg-inline-block">
										<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-desktop-analytics" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
											<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
											<rect x="3" y="4" width="18" height="12" rx="1"></rect>
											<path d="M7 20h10"></path>
											<path d="M9 16v4"></path>
											<path d="M15 16v4"></path>
											<path d="M9 12v-4"></path>
											<path d="M12 12v-1"></path>
											<path d="M15 12v-2"></path>
											<path d="M12 12v-1"></path>
										</svg>
									</span>
									<span class="nav-link-title"> Laporan </span>
								</a>
								<div class="dropdown-menu ">
									<div class="dropdown-menu-columns">
										<div class="dropdown-menu-column">
											<a class="dropdown-item" href="index.php?pg=laporan">Monitoring</a>
										</div>
										<!-- <div class="dropdown-menu-column">
											<a class="dropdown-item" href="navigation.html">
												Navigation
											</a>
										</div> -->
									</div>
								</div>
							</li>
						</ul>
						<div class="
                  my-2 my-md-0
                  flex-grow-1 flex-md-grow-0
                  order-first order-md-last
                ">
							<h2 id="timestamp"></h2>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="page-wrapper">
			<!-- buat kontent -->
			<?php include "page.php";
			?>

			<!-- bagian footer -->
			<footer class="footer footer-transparent d-print-none">
				<div class="container">
					<div class="row text-center align-items-center flex-row-reverse">
						<div class="col-lg-auto ms-lg-auto">
							<ul class="list-inline list-inline-dots mb-0">
								<li class="list-inline-item">
									<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-layout-grid" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
										<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
										<rect x="4" y="4" width="6" height="6" rx="1"></rect>
										<rect x="14" y="4" width="6" height="6" rx="1"></rect>
										<rect x="4" y="14" width="6" height="6" rx="1"></rect>
										<rect x="14" y="14" width="6" height="6" rx="1"></rect>
									</svg>
									Monitoring Server
								</li>
								<li class="list-inline-item">
									Skripsi
								</li>
								<li class="list-inline-item">
									<?= date("Y"); ?>
								</li>
							</ul>
						</div>
						<div class="col-12 col-lg-auto mt-3 mt-lg-0">
							<ul class="list-inline list-inline-dots mb-0">
								<li class="list-inline-item">
									<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
										<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
										<circle cx="12" cy="7" r="4"></circle>
										<path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
									</svg>
									Ahmad Juantoro
								</li>
								<li class="list-inline-item">
									171011400142
								</li>
							</ul>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>
	<div class="modal modal-blur fade" id="modal-profile" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog  modal-dialog-centered" role="document">
			<div class="modal-content">
				<form action="" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<?= $dataUser['id_pic']; ?>">
					<input type="hidden" name="foto_lama" value="<?= $dataUser['foto']; ?>">
					<input type="hidden" name="pg" value="<?= $_GET['pg']; ?>">
					<div class="modal-header">
						<h5 class="modal-title">Profile <?= $dataUser['nm_pic']; ?></h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="col-lg-12">
							<div class="mb-3">
								<label class="form-label">Nama</label>
								<input type="text" class="form-control" name="nama" value="<?= $dataUser['nm_pic']; ?>" placeholder="Nama" required>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="mb-3">
								<label class="form-label">Username</label>
								<input type="email" class="form-control" name="username" value="<?= $dataUser['email']; ?>" placeholder="Email" required>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="mb-3">
								<label class="form-label">Password</label>
								<input type="password" class="form-control" name="password" placeholder="Password">
								<label style="color: red; font-size: 12px;"><i>*Kosongkan jika tidak dirubah</i></label>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="mb-3">
								<label class="form-label">Posisi</label>
								<select class="form-select" name="posisi">
									<option value="Admin IT" <?= $dataUser['posisi'] == 'Admin IT' ? 'selected' : ''; ?>>Admin IT</option>
									<option value="Head IT" <?= $dataUser['posisi'] == 'Head IT' ? 'selected' : ''; ?>>Head IT</option>
									<option value="IT Support" <?= $dataUser['posisi'] == 'IT Support' ? 'selected' : ''; ?>>IT Support</option>
									<option value="Programmer" <?= $dataUser['posisi'] == 'Programmer' ? 'selected' : ''; ?>>Programmer</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="mb-3">
									<label class="form-label">Telepon</label>
									<div class="input-group input-group-flat">
										<span class="input-group-text">
											+62
										</span>
										<input type="number" class="form-control" name="telepon" value="<?= $dataUser['no_telp']; ?>" placeholder="Telepon">
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="mb-3">
									<label class="form-label">Telegram ID</label>
									<input type="number" class="form-control" name="chat_id" placeholder="Belum Aktif" disabled>
								</div>
							</div>
						</div>
						<label class="form-label">Status</label>
						<div class="form-selectgroup-boxes row mb-3">
							<div class="col-lg-12 ">
								<label class="form-selectgroup-item">
									<input type="checkbox" name="user_aktif" class="form-selectgroup-input" <?= $dataUser['user_aktif'] == 1 ? 'checked' : ''; ?> disabled>
									<span class="form-selectgroup-label d-flex align-items-center p-3">
										<span class="me-3 mb-3">
											<span class="form-selectgroup-check"></span>
										</span>
										<span class="form-selectgroup-label-content">
											<span class="form-selectgroup-title strong mb-1">User Aktif</span>
											<span class="d-block text-muted">Status login user ke sistem (Aktif/Non Aktif)</span>
										</span>
									</span>
								</label>
							</div>
							<!-- <div class="col-lg-6">
								<label class="form-selectgroup-item">
									<input type="checkbox" name="monitoring_aktif" role="switch" class="form-selectgroup-input" <?= $dataUser['monitoring_aktif'] == 1 ? 'checked' : ''; ?>>
									<span class="form-selectgroup-label d-flex align-items-center p-3">
										<span class="me-3">
											<span class="form-selectgroup-check"></span>
										</span>
										<span class="form-selectgroup-label-content">
											<span class="form-selectgroup-title strong mb-1">Monitoring Status</span>
											<span class="d-block text-muted">Status monitoring pindai IP/Domain server</span>
										</span>
									</span>
								</label>
							</div> -->
						</div>
						<div class="row">
							<div class="col-lg-5">
								<div class="mb-3">
									<label for="foto" class="form-label">Foto</label>
									<img src="../assets/img/foto/<?= cek_foto($dataUser['foto']); ?>" class="img-thumbnail" alt="Foto">
								</div>
							</div>
							<div class="col-lg-7">
								<div class="mb-3">
									<label for="foto" class="form-label mb-5"></label>
									<input class="form-control" type="file" id="foto" name="foto" accept="image/*">
									<label style="color: red; font-size: 12px;"><i>*Kosongkan jika tidak dirubah</i></label>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<a href="#" class="btn btn-dafault" data-bs-dismiss="modal">
							<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
								<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
								<line x1="18" y1="6" x2="6" y2="18"></line>
								<line x1="6" y1="6" x2="18" y2="18"></line>
							</svg>
							Batal
						</a>
						<button class="btn btn-primary ms-auto" type="submit" name="rubah_profil" value="simpan">
							<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
								<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
								<path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"></path>
								<circle cx="12" cy="14" r="2"></circle>
								<polyline points="14 4 14 8 8 8 8 4"></polyline>
							</svg>
							Simpan
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Libs JS -->
	<script src="../assets/dist/apexcharts.min.js"></script>
	<!-- Tabler Core -->
	<script src="../assets/js/tabler.min.js"></script>

	<!-- data tables -->
	<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"> </script> -->

	<!-- <script>
		$(document).ready(function() {
			$('#table-dtNormal').DataTable();
		});
	</script> -->


	<!-- biar bisa klik didalem tabel -->
	<script>
		jQuery(document).ready(function($) {
			$(".clickable-row").click(function() {
				window.location = $(this).data("href");
			});
		});
	</script>

	<script>
		// Function ini dijalankan ketika Halaman ini dibuka pada browser
		$(function() {
			setInterval(timestamp, 1000); //fungsi yang dijalan setiap detik, 1000 = 1 detik
		});

		//Fungi ajax untuk Menampilkan Jam dengan mengakses File ajax_timestamp.php
		function timestamp() {
			$.ajax({
				url: '../jam.php',
				success: function(data) {
					$('#timestamp').html(data);
				},
			});
		}
	</script>

	<script>
		// @formatter:off
		document.addEventListener("DOMContentLoaded", function() {
			window.ApexCharts && (new ApexCharts(document.getElementById('chart-demo-pie'), {
				chart: {
					type: "donut",
					fontFamily: 'inherit',
					height: 240,
					sparkline: {
						enabled: true
					},
					animations: {
						enabled: false
					},
				},
				fill: {
					opacity: 1,
				},
				series: [
					<?php while ($dataChartTotal = mysqli_fetch_assoc($queryChartTotal)) {
						echo $dataChartTotal['total'] . ",";
					} ?>
				],
				labels: [
					<?php while ($dataIPTotal = mysqli_fetch_assoc($queryIPTotal)) {
						echo "'" . $dataIPTotal['ip_address'] . "',";
					} ?>
				],
				grid: {
					strokeDashArray: 4,
				},
				colors: ["#206bc4", "#79a6dc", "#d2e1f3", "#e9ecf1", "#206bc4", "#79a6dc", "#d2e1f3", "#e9ecf1"],
				legend: {
					show: true,
					position: 'bottom',
					offsetY: 12,
					markers: {
						width: 10,
						height: 10,
						radius: 100,
					},
					itemMargin: {
						horizontal: 8,
						vertical: 8
					},
				},
				tooltip: {
					fillSeriesColor: false
				},
			})).render();
		});
		// @formatter:on
	</script>

	<script>
		var options = {
			chart: {
				height: 400,
				type: "heatmap",
				toolbar: {
					show: false,
				},
			},
			dataLabels: {
				enabled: false
			},
			colors: ["#206bc4", ],
			series: [
				<?php while ($dataGrafik = mysqli_fetch_assoc($queryGrafik)) { ?> {
						name: "<?= $dataGrafik['bulan']; ?>",
						data: [{
							x: '1',
							y: <?= $dataGrafik['tgl_1']; ?>
						}, {
							x: '2',
							y: <?= $dataGrafik['tgl_2']; ?>
						}, {
							x: '3',
							y: <?= $dataGrafik['tgl_3']; ?>
						}, {
							x: '4',
							y: <?= $dataGrafik['tgl_4']; ?>
						}, {
							x: '5',
							y: <?= $dataGrafik['tgl_5']; ?>
						}, {
							x: '6',
							y: <?= $dataGrafik['tgl_6']; ?>
						}, {
							x: '7',
							y: <?= $dataGrafik['tgl_7']; ?>
						}, {
							x: '8',
							y: <?= $dataGrafik['tgl_8']; ?>
						}, {
							x: '9',
							y: <?= $dataGrafik['tgl_9']; ?>
						}, {
							x: '10',
							y: <?= $dataGrafik['tgl_10']; ?>
						}, {
							x: '11',
							y: <?= $dataGrafik['tgl_11']; ?>
						}, {
							x: '12',
							y: <?= $dataGrafik['tgl_12']; ?>
						}, {
							x: '13',
							y: <?= $dataGrafik['tgl_13']; ?>
						}, {
							x: '14',
							y: <?= $dataGrafik['tgl_14']; ?>
						}, {
							x: '15',
							y: <?= $dataGrafik['tgl_15']; ?>
						}, {
							x: '16',
							y: <?= $dataGrafik['tgl_16']; ?>
						}, {
							x: '17',
							y: <?= $dataGrafik['tgl_17']; ?>
						}, {
							x: '18',
							y: <?= $dataGrafik['tgl_18']; ?>
						}, {
							x: '19',
							y: <?= $dataGrafik['tgl_19']; ?>
						}, {
							x: '20',
							y: <?= $dataGrafik['tgl_20']; ?>
						}, {
							x: '21',
							y: <?= $dataGrafik['tgl_21']; ?>
						}, {
							x: '22',
							y: <?= $dataGrafik['tgl_22']; ?>
						}, {
							x: '23',
							y: <?= $dataGrafik['tgl_23']; ?>
						}, {
							x: '24',
							y: <?= $dataGrafik['tgl_24']; ?>
						}, {
							x: '25',
							y: <?= $dataGrafik['tgl_25']; ?>
						}, {
							x: '26',
							y: <?= $dataGrafik['tgl_26']; ?>
						}, {
							x: '27',
							y: <?= $dataGrafik['tgl_27']; ?>
						}, {
							x: '28',
							y: <?= $dataGrafik['tgl_28']; ?>
						}, {
							x: '29',
							y: <?= $dataGrafik['tgl_29']; ?>
						}, {
							x: '30',
							y: <?= $dataGrafik['tgl_30']; ?>
						}, {
							x: '31',
							y: <?= $dataGrafik['tgl_31']; ?>
						}, ]
					},
				<?php } ?>
			],
			xaxis: {
				type: "category"
			},
			legend: {
				show: false,
			},
		};
		(new ApexCharts(document.querySelector("#chart-heatmap-basic"), options)).render();

		// size db
		// $(document).ready(function() {
		// 	// Kirim permintaan Ajax untuk mengambil data dari server
		// 	$.ajax({
		// 		url: 'http://e-boss.ekanuri.co.id/open_api/size_db.php',
		// 		type: 'GET',
		// 		dataType: 'json',
		// 		success: function(data) {
		// 			// Iterasi melalui data dan menampilkan dalam tabel
		// 			$.each(data, function(index, item) {
		// 				$('#tbl_').append(
		// 					'<tr>' +
		// 					'<td>' + item.nm_db + '</td>' +
		// 					'<td>' + item.size_db + '</td>' +
		// 					'<td>' + item.size_db_mb + ' MB</td>' +
		// 					'</tr>'
		// 				);
		// 			});
		// 		},
		// 		error: function(error) {
		// 			console.log('Error:', error);
		// 		}
		// 	});
		// });

		// size disk
		// function getServerSize(data) {
		// 	var ip = data;
		// 	console.log(ip)
		// 	// $(document).ready(function() {
		// 	$.ajax({
		// 		url: 'http://' + ip + '/open_api/size_disk.php',
		// 		type: 'GET',
		// 		dataType: 'json',
		// 		success: function(data) {
		// 			// console.log('Total Space: ' + data.totalSpaceGB + ' GB');
		// 			// console.log('Used Space: ' + data.usedSpaceGB + ' GB');
		// 			// console.log('Free Space: ' + data.freeSpaceGB + ' GB');

		// 			document.getElementById('totalSpace').innerHTML = data.totalSpaceGB;
		// 			document.getElementById('usedSpace').innerHTML = data.usedSpaceGB;
		// 			document.getElementById('freeSpace').innerHTML = data.freeSpaceGB;
		// 		},
		// 		error: function(error) {
		// 			console.error('Error:', error);
		// 		}
		// 	});
		// 	// });
		// }
	</script>
</body>

</html>