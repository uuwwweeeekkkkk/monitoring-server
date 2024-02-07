<?php
$page = isset($_GET['pg']) ? $_GET['pg'] : "";

if ($page == "") {
    include_once "home.php";
} elseif ($page == "ip_domain") {
    include_once "ip_domain.php";
} elseif ($page == "pic") {
    include_once "pic.php";
} elseif ($page == "laporan") {
    include_once "laporan.php";
} elseif ($page == "dtl_laporan") {
    include_once "dtl_laporan.php";
}
