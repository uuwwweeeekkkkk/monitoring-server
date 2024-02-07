<?php

$queryMonitoring = mysqli_query($konek, "SELECT id_ip, kd_ip, ip_address, nm_pic, COUNT(ip_id) AS total
                                            FROM monitoring_rto
                                            RIGHT JOIN data_ip
                                                ON id_ip = ip_id
                                            JOIN pic
                                                ON id_pic = pic_id
                                            WHERE kirim_telegram IS NOT NULL
                                            GROUP BY id_ip, kd_ip, ip_address, nm_pic
                            ");

$no = 1;
?>

<div class="container-xxl">
    <!-- Page title -->
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">Laporan</div>
                <h2 class="page-title">Monitoring</h2>
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
                        <table id="table-dtNormal" class="table table-vcenter table-mobile-md card-table datatable" data-bs-toggle="tooltip" title="Klik list untuk detail">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>IP/Domain</th>
                                    <th>PIC</th>
                                    <th class="text-center">Jumlah Monitoring</th>
                                    <!-- <th class="w- text-center">Jumlah Monitoring</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($dataMonitoring = mysqli_fetch_assoc($queryMonitoring)) { ?>
                                    <tr style="cursor: pointer;" class="clickable-row" data-href="index.php?pg=dtl_laporan&id=<?= enkripsi($dataMonitoring['id_ip']); ?>">
                                        <td><?= $no; ?></td>
                                        <td><?= $dataMonitoring['kd_ip']; ?></td>
                                        <td><?= $dataMonitoring['ip_address']; ?></td>
                                        <td><?= $dataMonitoring['nm_pic']; ?></td>
                                        <td class="text-center"><span class="badge bg-red"><?= $dataMonitoring['total']; ?></span></td>
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

<!-- MODAL BUAT TAMBAH DATA -->
<div class="modal modal-blur fade" id="modal-tambah" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="manage_pic.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah PIC</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama" value="" placeholder="Nama" required>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="email" class="form-control" name="username" value="" placeholder="Email" required>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                            <!-- <label style="color: red; font-size: 12px;"><i>*Kosongkan jika tidak dirubah</i></label> -->
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">Posisi</label>
                            <select class="form-select" name="posisi">
                                <option value="Admin IT">Admin IT</option>
                                <option value="Head IT">Head IT</option>
                                <option value="IT Support">IT Support</option>
                                <option value="Programmer">Programmer</option>
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
                                    <input type="number" class="form-control" name="telepon" value="" placeholder="Telepon">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Telegram ID</label>
                                <input type="number" class="form-control" name="chat_id" placeholder="Belum Aktif" disabled value="706694762">
                            </div>
                        </div>
                    </div>
                    <label class="form-label">Status</label>
                    <div class="form-selectgroup-boxes row mb-3">
                        <div class="col-lg-12 ">
                            <label class="form-selectgroup-item">
                                <input type="checkbox" name="user_aktif" class="form-selectgroup-input" checked>
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
                                <img src="../assets/img/foto/avatars.png" class="img-thumbnail" alt="Foto">
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="mb-3">
                                <label for="foto" class="form-label mb-5"></label>
                                <input class="form-control" type="file" id="foto" name="foto" accept="image/*">
                                <!-- <label style="color: red; font-size: 12px;"><i>*Kosongkan jika tidak dirubah</i></label> -->
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