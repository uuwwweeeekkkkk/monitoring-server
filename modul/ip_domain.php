<?php

// ngambil kode buat SERVER
$queryMax = mysqli_query($konek, "SELECT MAX(kd_ip) AS kd_ip FROM data_ip");
$dataMax = mysqli_fetch_assoc($queryMax);
$idUrut = $dataMax['kd_ip'];
$noUrut = (int) substr($idUrut, 3, 3);
$noUrut++;
$kodeIP = 'SRV' . sprintf("%03s", $noUrut);

// query data IP/Domain
$queryIP = mysqli_query($konek, "SELECT * FROM data_ip
                                    JOIN pic
                                        ON id_pic = pic_id
                                    ORDER BY kd_ip ASC");

$no = 1;

?>

<div class="container-xxl">
    <!-- Page title -->
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">Master Data</div>
                <h2 class="page-title">IP Address/Domain</h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-tambah">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        Tambah Data
                    </a>
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
                    <div class="card-body">
                        <div class="accordion" id="accordion-example">
                            <?php while ($dataIP = mysqli_fetch_assoc($queryIP)) { ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading-<?= $no; ?>">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $no; ?>" aria-expanded="false">
                                            <?= $dataIP['kd_ip']; ?> #<?= $no; ?>
                                        </button>
                                    </h2>
                                    <div id="collapse-<?= $no; ?>" class="accordion-collapse collapse" data-bs-parent="#accordion-example">
                                        <div class="accordion-body pt-0">
                                            Alamat IP/Domain <strong><?= $dataIP['ip_address']; ?></strong>,
                                            dengan Nama Unit <u><?= $dataIP['nm_unit']; ?></u>
                                            yang berlokasi di <a href="http://maps.google.com/maps?q=<?= $dataIP['gps_x']; ?>,<?= $dataIP['gps_y']; ?>" target="_blank">[Lihat Lokasi]</a>.
                                            <br>PIC/Penanggung jawab Server <strong><?= $dataIP['nm_pic']; ?></strong>, kategori <code><?= $dataIP['kategori']; ?></code>
                                            <br><br>
                                            <button type="button" class="btn btn-sm btn-link link-secondary me-auto" data-bs-toggle="modal" data-bs-target="#modal-rubah-<?= $dataIP['id_ip']; ?>">Rubah</button>
                                            <button type="button" class="btn btn-sm btn-link link-secondary me-auto" data-bs-toggle="modal" data-bs-target="#modal-hapus-<?= $dataIP['id_ip']; ?>">Hapus</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- MODAL HAPUS -->
                                <div class="modal modal-blur fade" id="modal-hapus-<?= $dataIP['id_ip']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <form action="manage_ip.php" method="POST" enctype="multipart/form-data">
                                                <input type="hidden" name="id_ip" value="<?= $dataIP['id_ip']; ?>">
                                                <div class="modal-body">
                                                    <div class="modal-title">Apakah anda yakin?</div>
                                                    <div>Ingin menghapus data <strong><?= $dataIP['ip_address']; ?></strong><br>Semua data monitoring akan ikut terhapus.</div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger" name="hapus">Ya, saya yakin</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- END MODAL HAPUS -->
                                <!-- MODAL BUAT RUBAH DATA -->
                                <div class="modal modal-blur fade" id="modal-rubah-<?= $dataIP['id_ip']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog  modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <form action="manage_ip.php" method="POST" enctype="multipart/form-data">
                                                <input type="hidden" name="id_ip" value="<?= $dataIP['id_ip']; ?>">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Rubah IP Address/Domain <?= $dataIP['ip_address']; ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Kode</label>
                                                            <input type="text" class="form-control" name="kode" value="<?= $dataIP['kd_ip']; ?>" placeholder="Kode" required readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">IP Address/Domain</label>
                                                            <input type="text" class="form-control" name="ip_domain" value="<?= $dataIP['ip_address']; ?>" placeholder="101.125.xx.xx / name.domain.com" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Nama Unit</label>
                                                            <input type="text" class="form-control" name="nm_unit" placeholder="Server XXX" value="<?= $dataIP['nm_unit']; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Kategori</label>
                                                            <select class="form-select" name="kategori">
                                                                <option value="Server Application" <?= $dataIP['kategori'] == "Server Application" ? "selected=selected" : ""; ?>>Server Application</option>
                                                                <option value="Server File" <?= $dataIP['kategori'] == "Server File" ? "selected=selected" : ""; ?>>Server File</option>
                                                                <option value="Server FTP" <?= $dataIP['kategori'] == "Server FTP" ? "selected=selected" : ""; ?>>Server FTP</option>
                                                                <option value="Server Mail" <?= $dataIP['kategori'] == "Server Mail" ? "selected=selected" : ""; ?>>Server Mail</option>
                                                                <option value="Server Mikrotik" <?= $dataIP['kategori'] == "Server Mikrotik" ? "selected=selected" : ""; ?>>Server Mikrotik</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">PIC</label>
                                                            <select class="form-select" name="pic">
                                                                <?php $queryPIC = mysqli_query($konek, "SELECT * FROM pic ORDER BY nm_pic ASC");
                                                                while ($dataPIC = mysqli_fetch_assoc($queryPIC)) { ?>
                                                                    <option value="<?= $dataPIC['id_pic']; ?>" <?= $dataPIC['id_pic'] == $dataIP['pic_id'] ? 'selected' : ''; ?>><?= $dataPIC['nm_pic']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">Latitude</label>
                                                                <div class="input-group input-group-flat">
                                                                    <span class="input-group-text">
                                                                        X
                                                                    </span>
                                                                    <input type="text" class="form-control" name="gps_x" value="<?= $dataIP['gps_x']; ?>" placeholder="-6.193125">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="form-label">Longitude</label>
                                                                <div class="input-group input-group-flat">
                                                                    <span class="input-group-text">
                                                                        Y
                                                                    </span>
                                                                    <input type="text" class="form-control" name="gps_y" value="<?= $dataIP['gps_y']; ?>" placeholder="106.821810">
                                                                </div>
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
                                                    <button class="btn btn-primary ms-auto" type="submit" name="rubah" value="simpan">
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
                                <!-- END MODAL RUBAH -->
                            <?php $no++;
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- MODAL BUAT TAMBAH DATA -->
<div class="modal modal-blur fade" id="modal-tambah" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="manage_ip.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah IP Address/Domain</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">Kode</label>
                            <input type="text" class="form-control" name="kode" value="<?= $kodeIP; ?>" placeholder="Kode" required readonly>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">IP Address/Domain</label>
                            <input type="text" class="form-control" name="ip_domain" value="" placeholder="101.125.xx.xx / name.domain.com" required>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">Nama Unit</label>
                            <input type="text" class="form-control" name="nm_unit" placeholder="Server XXX" required>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select class="form-select" name="kategori">
                                <option value="Server Application">Server Application</option>
                                <option value="Server File">Server File</option>
                                <option value="Server FTP">Server FTP</option>
                                <option value="Server Mail">Server Mail</option>
                                <option value="Server Mikrotik">Server Mikrotik</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">PIC</label>
                            <select class="form-select" name="pic">
                                <?php $queryPIC = mysqli_query($konek, "SELECT * FROM pic ORDER BY nm_pic ASC");
                                while ($dataPIC = mysqli_fetch_assoc($queryPIC)) { ?>
                                    <option value="<?= $dataPIC['id_pic']; ?>"><?= $dataPIC['nm_pic']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Latitude</label>
                                <div class="input-group input-group-flat">
                                    <span class="input-group-text">
                                        X
                                    </span>
                                    <input type="text" class="form-control" name="gps_x" value="" placeholder="-6.193125">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Longitude</label>
                                <div class="input-group input-group-flat">
                                    <span class="input-group-text">
                                        Y
                                    </span>
                                    <input type="text" class="form-control" name="gps_y" value="" placeholder="106.821810">
                                </div>
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
                    <button class="btn btn-primary ms-auto" type="submit" name="tambah" value="simpan">
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