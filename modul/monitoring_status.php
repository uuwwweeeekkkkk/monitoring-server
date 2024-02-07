<?php
session_start();
include "../fungsi.php";

// autetikasi Login
if (empty($_SESSION['usr']) || $_SESSION['usr'] == '' || !isset($_SESSION['usr'])) {
    header("Location: ../");
}

if (isset($_GET['id'])) {
    $id = dekripsi($_GET['id']);
    $status = dekripsi($_GET['status']);

    $updStatus = mysqli_query($konek, "UPDATE pic SET monitoring_aktif = '$status' WHERE id_pic = '$id'");

    if ($updStatus) {
        header('Location: .');
    }
} else {
    header('Location: .');
}
