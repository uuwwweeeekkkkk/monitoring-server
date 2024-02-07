<?php

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

$queryIP = mysqli_query($konek, "SELECT * FROM data_ip WHERE id_ip = '$id'");
$dataIP = mysqli_fetch_assoc($queryIP);

$no = 1;

?>

<div class="container-xxl">
    <!-- Page title -->
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">Detail Laporan</div>
                <h2 class="page-title"><?= $dataIP['nm_unit'] . " [" . $dataIP['ip_address']; ?>]</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="cetak_excel.php?id=<?= enkripsi($id); ?>" class="btn btn-success d-none d-sm-inline-block" data-bs-toggle="tooltip" title="Cetak Excel">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-analytics" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                            <line x1="9" y1="17" x2="9" y2="12"></line>
                            <line x1="12" y1="17" x2="12" y2="16"></line>
                            <line x1="15" y1="17" x2="15" y2="14"></line>
                        </svg>
                        Cetak Excel
                    </a>
                    <!-- <a href="cetak_pdf.php?id=<?= enkripsi($id); ?>" target="_blank" class="btn btn-icon btn-primary d-none d-sm-inline-block" data-bs-toggle="tooltip" title="Cetak PDF">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-text" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                            <line x1="9" y1="9" x2="10" y2="9"></line>
                            <line x1="9" y1="13" x2="15" y2="13"></line>
                            <line x1="9" y1="17" x2="15" y2="17"></line>
                        </svg>
                    </a> -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xxl">
        <?php if (isset($_COOKIE['pesan'])) { ?>
            <div class="alert alert-important alert-<?= $_COOKIE['warna']; ?> alert-dismissible" role="alert">
                <div class="d-flex">
                    <div>
                        <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                        <!-- SVG icon code with class="alert-icon" -->
                    </div>
                    <div>
                        <?= $_COOKIE['pesan']; ?>
                    </div>
                </div>
                <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        <?php } ?>
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-vcenter table-mobile-md card-table datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Waktu Down</th>
                                    <th>Waktu UP</th>
                                    <th>Notifikasi Telegram</th>
                                    <th>Status Sekarang</th>
                                    <th>Durasi Pemulihan</th>
                                    <!-- <th class="w-1 text-center">Opsi</th> -->
                                </tr>
                            </thead>
                            <tbody>
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>