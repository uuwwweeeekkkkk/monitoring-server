<?php

// query data PIC
$queryPIC = mysqli_query($konek, "SELECT * FROM pic ORDER BY nm_pic ASC");

$no = 1;

?>

<div class="container-xxl">
    <!-- Page title -->
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">Master Data</div>
                <h2 class="page-title">PIC</h2>
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
                    <div class="table-responsive">
                        <table class="table table-vcenter table-mobile-md card-table datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Telepon</th>
                                    <th>Posisi</th>
                                    <th>User Aktif</th>
                                    <th class="w-1 text-center">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($dataPIC = mysqli_fetch_assoc($queryPIC)) { ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td data-label="Name">
                                            <div class="d-flex py-1 align-items-center">
                                                <span class="avatar me-2" style="background-image: url(../assets/img/foto/<?= cek_foto($dataPIC['foto']); ?>)"></span>
                                                <div class="flex-fill">
                                                    <div class="font-weight-medium"><?= $dataPIC['nm_pic']; ?></div>
                                                    <div class="text-muted"><a href="mailto:<?= $dataPIC['email']; ?>" class="text-reset"><?= $dataPIC['email']; ?></a></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="Title">
                                            <a href="http://wa.me/62<?= $dataPIC['no_telp']; ?>" target="_blank">+62 <?= $dataPIC['no_telp']; ?></a>
                                            <div class="text-muted">ID <?= $dataPIC['chat_id']; ?></div>
                                        </td>
                                        <td class="text-muted" data-label="Role">
                                            <?= $dataPIC['posisi'] ?>
                                        </td>
                                        <td class="text-muted" data-label="Role">
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input" role="switch" <?= $dataPIC['user_aktif'] == 1 ? 'checked' : ''; ?> disabled>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-list flex-nowrap">
                                                <button class="btn btn-yellow  w-100 btn-icon" data-bs-toggle="modal" data-bs-target="#modal-rubah-<?= $dataPIC['id_pic']; ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" data-bs-toggle="tooltip" title="Rubah">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"></path>
                                                        <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3"></path>
                                                        <line x1="16" y1="5" x2="19" y2="8"></line>
                                                    </svg>
                                                </button>
                                                <button class="btn btn-red  w-100 btn-icon" data-bs-toggle="modal" data-bs-target="#modal-hapus-<?= $dataPIC['id_pic']; ?>">
                                                    <!-- <a href="index.php?pg=pic&id=<?= enkripsi($dataPIC['id_pic']); ?>&foto=<?= enkripsi($dataPIC['foto']); ?>" onclick="return confirm('Yakin PIC <?= $dataPIC['nm_pic']; ?> ingin dihapus?')" class="btn btn-red  w-100 btn-icon" data-bs-toggle="tooltip" title="Hapus"> -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" data-bs-toggle="tooltip" title="Hapus">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <line x1="4" y1="7" x2="20" y2="7"></line>
                                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                    </svg>
                                                    <!-- </a> -->
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- MODAL HAPUS -->
                                    <div class="modal modal-blur fade" id="modal-hapus-<?= $dataPIC['id_pic']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form action="manage_pic.php" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" name="id" value="<?= $dataPIC['id_pic']; ?>">
                                                    <input type="hidden" name="foto" value="<?= $dataPIC['foto']; ?>">
                                                    <div class="modal-body">
                                                        <div class="modal-title">Apakah anda yakin?</div>
                                                        <div>Ingin menghapus data <strong><?= $dataPIC['nm_pic']; ?></strong></div>
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
                                    <!-- MODAL RAMBO, YANG IKUT NGELOOPING JUGA -->
                                    <div class="modal modal-blur fade" id="modal-rubah-<?= $dataPIC['id_pic']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog  modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form action="manage_pic.php" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" name="id" value="<?= $dataPIC['id_pic']; ?>">
                                                    <input type="hidden" name="foto_lama" value="<?= $dataPIC['foto']; ?>">
                                                    <input type="hidden" name="pg" value="<?= $_GET['pg']; ?>">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Rubah Profile <?= $dataPIC['nm_pic']; ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">Nama</label>
                                                                <input type="text" class="form-control" name="nama" value="<?= $dataPIC['nm_pic']; ?>" placeholder="Nama" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">Username</label>
                                                                <input type="email" class="form-control" name="username" value="<?= $dataPIC['email']; ?>" placeholder="Email" required>
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
                                                                    <option value="Admin IT" <?= $dataPIC['posisi'] == 'Admin IT' ? 'selected' : ''; ?>>Admin IT</option>
                                                                    <option value="Head IT" <?= $dataPIC['posisi'] == 'Head IT' ? 'selected' : ''; ?>>Head IT</option>
                                                                    <option value="IT Support" <?= $dataPIC['posisi'] == 'IT Support' ? 'selected' : ''; ?>>IT Support</option>
                                                                    <option value="Programmer" <?= $dataPIC['posisi'] == 'Programmer' ? 'selected' : ''; ?>>Programmer</option>
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
                                                                        <input type="number" class="form-control" name="telepon" value="<?= $dataPIC['no_telp']; ?>" placeholder="Telepon">
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
                                                                    <input type="checkbox" name="user_aktif" class="form-selectgroup-input" <?= $dataPIC['user_aktif'] == 1 ? 'checked' : ''; ?>>
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
                                                                    <input type="checkbox" name="monitoring_aktif" role="switch" class="form-selectgroup-input" <?= $dataPIC['monitoring_aktif'] == 1 ? 'checked' : ''; ?>>
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
                                                                    <img src="../assets/img/foto/<?= cek_foto($dataPIC['foto']); ?>" class="img-thumbnail" alt="Foto">
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
                                    <!-- END MODAL REMBO -->
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
                                    <input type="number" class="form-control" name="telepon" value="0" placeholder="Telepon">
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