<?php
include "../fungsi.php";


if (isset($_POST['tambah'])) {
    $kode = $_POST['kode'];
    $ip_domain = $_POST['ip_domain'];
    $nm_unit = $_POST['nm_unit'];
    $kategori = $_POST['kategori'];
    $pic = $_POST['pic'];
    $gps_x = $_POST['gps_x'];
    $gps_y = $_POST['gps_y'];

    $ip_cek = mysqli_query($konek, "SELECT ip_address FROM data_ip WHERE ip_address = '$ip_domain'");
    $total_cek = mysqli_num_rows($ip_cek);

    if ($total_cek > 0) {
        setcookie('pesan', 'Data gagal ditambahkan!<br>IP/Domain sudah ada sebelumnya!', time() + (3), '/');
        setcookie('warna', 'warning', time() + (3), '/');
        header('Location: index.php?pg=ip_domain');
        // echo "<script>alert('Gagal menambah data, IP/Domain sudah ada sebelumnya!');</script>";
    } else {
        $insert = mysqli_query($konek, "INSERT INTO data_ip (kd_ip, ip_address, nm_unit, kategori, pic_id, gps_x, gps_y) VALUES
                                                ('$kode', '$ip_domain', '$nm_unit', '$kategori', '$pic', '$gps_x', '$gps_y')
                            ");

        if ($insert) {
            setcookie('pesan', 'Data berhasil ditambahkan!', time() + (3), '/');
            setcookie('warna', 'success', time() + (3), '/');
        } else {
            setcookie('pesan', 'Data gagal ditambahkan!<br>' . mysqli_error($konek), time() + (3), '/');
            setcookie('warna', 'danger', time() + (3), '/');
        }
        header('Location: index.php?pg=ip_domain');
    }
}

if (isset($_POST['rubah'])) {
    $id_ip = $_POST['id_ip'];
    $ip_domain = $_POST['ip_domain'];
    $nm_unit = $_POST['nm_unit'];
    $kategori = $_POST['kategori'];
    $pic = $_POST['pic'];
    $gps_x = $_POST['gps_x'];
    $gps_y = $_POST['gps_y'];

    $update = mysqli_query($konek, "UPDATE data_ip SET ip_address = '$ip_domain',
                                            nm_unit = '$nm_unit',
                                            kategori = '$kategori',
                                            pic_id = '$pic',
                                            gps_x = '$gps_x',
                                            gps_y = '$gps_y'
                                    WHERE id_ip = '$id_ip'
                            ");

    if ($update) {
        setcookie('pesan', 'Data berhasil dirubah!', time() + (3), '/');
        setcookie('warna', 'info', time() + (3), '/');
    } else {
        setcookie('pesan', 'Data gagal dirubah!<br>' . mysqli_error($konek), time() + (3), '/');
        setcookie('warna', 'danger', time() + (3), '/');
    }
    header('Location: index.php?pg=ip_domain');
}

if (isset($_POST['hapus'])) {
    $id_ip = $_POST['id_ip'];

    $delete = mysqli_query($konek, "DELETE FROM data_ip WHERE id_ip = '$id_ip'");

    if ($delete) {
        setcookie('pesan', 'Data berhasil dihapus!', time() + (3), '/');
        setcookie('warna', 'warning', time() + (3), '/');
    } else {
        setcookie('pesan', 'Data gagal dihapus!<br>' . mysqli_error($konek), time() + (3), '/');
        setcookie('warna', 'danger', time() + (3), '/');
    }
    header('Location: index.php?pg=ip_domain');
}
