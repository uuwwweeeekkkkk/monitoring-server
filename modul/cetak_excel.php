<?php
session_start();
include "../fungsi.php";

// autetikasi Login
if (empty($_SESSION['usr']) || $_SESSION['usr'] == '' || !isset($_SESSION['usr'])) {
    header("Location: ../");
}

if (isset($_GET['id'])) {
    $id = dekripsi($_GET['id']);
}

$queryDetail = mysqli_query($konek, "SELECT tanggal_rto, IFNULL(tanggal_reply, '-') AS tanggal_reply,
                                            IFNULL(kirim_telegram, '-') AS kirim_telegram,
                                            status, gps_x, gps_y,
                                            IFNULL(durasi, '-') AS durasi
                                        FROM monitoring_rto
                                        JOIN data_ip
                                            ON id_ip = ip_id
                                        WHERE id_ip = '$id'
                                        AND kirim_telegram IS NOT NULL
                                        ORDER BY tanggal_rto DESC
                            ");
$totalDetail = mysqli_num_rows($queryDetail);

$queryIP = mysqli_query($konek, "SELECT * FROM data_ip
                                    JOIN pic
                                        ON id_pic = pic_id
                                    WHERE id_ip = '$id'
                                    ORDER BY ip_address ASC
                        ");
$dataIP = mysqli_fetch_assoc($queryIP);

$no = 1;

if ($totalDetail > 0) {
    // fungsi header dengan mengirimkan raw data excel
    header("Content-type: application/vnd-ms-excel");

    // membuat nama file ekspor "export-to-excel.xls"
    header("Content-Disposition: attachment; filename=Laporan-Monitoring-(" . $dataIP['ip_address'] . ").xls");
?>
    <table>
        <tr>
            <td colspan="2"><b>Kode Server</b></td>
            <td colspan="2"><b> : <?= $dataIP['kd_ip']; ?></b></td>
        </tr>
        <tr>
            <td colspan="2"><b>Kategori Server</b></td>
            <td colspan="2"><b> : <?= $dataIP['kategori']; ?></b></td>
        </tr>
        <tr>
            <td colspan="2"><b>Nama Unit</b></td>
            <td colspan="2"><b> : <?= $dataIP['nm_unit']; ?></b></td>
        </tr>
        <tr>
            <td colspan="2"><b>IP/Domain</b></td>
            <td colspan="2"><b> : <?= $dataIP['ip_address']; ?></b></td>
        </tr>
        <tr>
            <td colspan="2"><b>PIC</b></td>
            <td colspan="2"><b> : <?= $dataIP['nm_pic']; ?></b></td>
        </tr>
    </table>

    <br>

    <table border="1">
        <tr>
            <th>No</th>
            <th>Waktu Down</th>
            <th>Waktu UP</th>
            <th>Notifikasi Telegram</th>
            <th>Status Sekarang</th>
            <th>Durasi Pemulihan</th>
        </tr>
        <?php while ($dataDetail = mysqli_fetch_assoc($queryDetail)) { ?>
            <tr>
                <td><?= $no; ?></td>
                <td><?= $dataDetail['tanggal_rto']; ?></td>
                <td><?= $dataDetail['tanggal_reply']; ?></td>
                <td><?= $dataDetail['kirim_telegram']; ?></td>
                <td><?= $dataDetail['status']; ?></td>
                <td><?= $dataDetail['durasi']; ?></td>
            </tr>
        <?php $no++;
        } ?>
    </table>
<?php } else {
    echo "<script>window.alert('Data laporan tidak ada (kosong)!');
                location='index.php?pg=dtl_laporan&id=" . $_GET['id'] . "'
            </script>";
} ?>