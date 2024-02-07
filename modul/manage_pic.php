<?php
include "../fungsi.php";

// TAMBAH DATA PIC
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $telepon = $_POST['telepon'];
    $chat_id = "706694762";
    $user_aktif = isset($_POST['user_aktif']) ? '1' : '0';
    // $monitoring_aktif = isset($_POST['monitoring_aktif']) ? '1' : '0';
    $posisi = $_POST['posisi'];

    // cek email apakah sudah ada
    $cek_email = mysqli_query($konek, "SELECT email FROM pic WHERE email = '$username'");
    $total_cek = mysqli_num_rows($cek_email);

    if ($total_cek > 0) {
        setcookie('pesan', 'Data gagal ditambahkan!<br>Email sudah ada sebelumnya!', time() + (3), '/');
        setcookie('warna', 'warning', time() + (3), '/');
        header('Location: index.php?pg=pic');
        // echo "<script>alert('Gagal menambah data, Email sudah ada sebelumnya!');</script>";
    } else {
        $foto_temp = $_FILES['foto']['name'];
        $path = $_FILES['foto']['tmp_name'];
        $ekstensi = pathinfo($foto_temp, PATHINFO_EXTENSION);
        $foto = $username . "." . $ekstensi;
        move_uploaded_file($path, "../assets/img/foto/$foto");

        $insert = mysqli_query($konek, "INSERT INTO pic (nm_pic, chat_id, email, password, posisi, no_telp, user_aktif, foto) VALUES
                                        ('$nama', '$chat_id', '$username', '$password', '$posisi', '$telepon', '$user_aktif', '$foto')
                            ");

        if ($insert) {
            setcookie('pesan', 'Data berhasil ditambahkan!', time() + (3), '/');
            setcookie('warna', 'success', time() + (3), '/');
        } else {
            setcookie('pesan', 'Data gagal ditambahkan!<br>' . mysqli_error($konek), time() + (3), '/');
            setcookie('warna', 'danger', time() + (3), '/');
        }
        header('Location: index.php?pg=pic');
    }
}

// RUBAH DATA PIC
if (isset($_POST['rubah'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $telepon = $_POST['telepon'];
    $chat_id = "706694762";
    $user_aktif = isset($_POST['user_aktif']) ? '1' : '0';
    // $monitoring_aktif = isset($_POST['monitoring_aktif']) ? '1' : '0';
    $posisi = $_POST['posisi'];

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
    } else {
        $password = "password = '" . md5($_POST['password']) . "',";
    }

    $update = mysqli_query($konek, "UPDATE pic SET nm_pic = '$nama',
                                            chat_id = '$chat_id',
                                            email = '$username', $password
                                            no_telp = '$telepon',
                                            posisi = '$posisi',
                                            user_aktif = '$user_aktif',
                                            foto = '$foto'
                                    WHERE id_pic = '$id'
    
                    ");

    if ($update) {

        setcookie('pesan', 'Data berhasil dirubah!', time() + (3), '/');
        setcookie('warna', 'info', time() + (3), '/');
    } else {
        setcookie('pesan', 'Data gagal dirubah!<br>' . mysqli_error($konek), time() + (3), '/');
        setcookie('warna', 'danger', time() + (3), '/');
    }
    header('Location: index.php?pg=pic');
}

if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    $foto = $_POST['foto'];

    $hapus = mysqli_query($konek, "DELETE FROM pic WHERE id_pic = '$id'");

    unlink("../assets/img/foto/$foto");

    if ($hapus) {
        setcookie('pesan', 'Data berhasil dihapus!', time() + (3), '/');
        setcookie('warna', 'warning', time() + (3), '/');
    } else {
        setcookie('pesan', 'Data gagal dihapus!<br>' . mysqli_error($konek), time() + (3), '/');
        setcookie('warna', 'danger', time() + (3), '/');
    }
    header('Location: index.php?pg=pic');
}
