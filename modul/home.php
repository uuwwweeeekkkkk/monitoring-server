<div class="container-xxl">
    <!-- Page title -->
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">Home</div>
                <h2 class="page-title">Dashboard</h2>
            </div>
            <!-- Page title actions -->
            <!-- <div class="col-auto ms-auto d-print-none">
							<div class="btn-list">
								<span class="d-none d-sm-inline">
									<a href="#" class="btn btn-white"> New view </a>
								</span>
								<a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
									
									<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
										<path stroke="none" d="M0 0h24v24H0z" fill="none" />
										<line x1="12" y1="5" x2="12" y2="19" />
										<line x1="5" y1="12" x2="19" y2="12" />
									</svg>
									Create new report
								</a>
								<a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Create new report">
									
									<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
										<path stroke="none" d="M0 0h24v24H0z" fill="none" />
										<line x1="12" y1="5" x2="12" y2="19" />
										<line x1="5" y1="12" x2="19" y2="12" />
									</svg>
								</a>
							</div>
						</div> -->
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
            <div class="col-lg-6">
                <div class="row row-cards">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div id="chart-heatmap-basic"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body p-2 text-center">
                                <br>
                                <div class="h1 m-0"><?= $dataServer['jumlah']; ?></div>
                                <div class="text-muted mb-3">Total Server</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body p-2 text-center">
                                <br>
                                <div class="h1 m-0"><?= $dataPIC['jumlah']; ?></div>
                                <div class="text-muted mb-3">Total PIC</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body p-2 text-center">
                                <div class="text-end text-red">
                                    <span class="text-red d-inline-flex align-items-center lh-1">
                                        <?= $persen; ?>%

                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <polyline points="3 7 9 13 13 9 21 17" />
                                            <polyline points="21 10 21 17 14 17" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="h1 m-0"><?= $dataMonitoring['jumlah']; ?></div>
                                <div class="text-muted mb-3">Server Down</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card" style="height: calc(24rem + 190px)">
                    <div class="card-body">
                        <h3 class="card-title">Chart Down Summary</h3>
                        <div id="chart-demo-pie"></div>
                    </div>
                    <div class=" card-body-scrollable card-body-scrollable-shadow">
                        <div class="divide-y">
                            <div class="card-table table-responsive">
                                <table class="table table-vcenter">
                                    <thead>
                                        <tr>
                                            <th>PIC</th>
                                            <th>IP/Domain</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($dataJumlah = mysqli_fetch_assoc($queryJumlah)) { ?>
                                            <tr style="cursor: pointer;" class="clickable-row" data-href="index.php?pg=dtl_laporan&id=<?= enkripsi($dataJumlah['id_ip']); ?>">
                                                <td class="w-1" data-bs-toggle="tooltip" title="<?= $dataJumlah['nm_pic']; ?>">
                                                    <span class="avatar avatar-sm" style="background-image: url(../assets/img/foto/<?= cek_foto($dataJumlah['foto']); ?>);"></span>
                                                </td>
                                                <td class="td-truncate">
                                                    <div class="text-truncate">
                                                        <?= $dataJumlah['ip_address']; ?>
                                                    </div>
                                                </td>
                                                <td class="text-nowrap text-muted text-center"><span class="badge bg-red"><?= $dataJumlah['total']; ?></span></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-7">
                <div class="card" style="height: 30rem">
                    <div class="card-body card-body-scrollable card-body-scrollable-shadow">
                        <div class="divide-y">
                            <?php $querySpace = mysqli_query($konek, "SELECT * FROM data_ip ORDER BY ip_address ASC");
                            while ($dataSpace = mysqli_fetch_assoc($querySpace)) { ?>

                                <script>
                                    // $(document).ready(function() {
                                    $.ajax({
                                        url: 'http://<?= $dataSpace['ip_address']; ?>/open_api/size_disk.php',
                                        type: 'GET',
                                        dataType: 'json',
                                        success: function(data) {
                                            // console.log('Total Space: ' + data.totalSpaceGB + ' GB');
                                            // console.log('Used Space: ' + data.usedSpaceGB + ' GB');
                                            // console.log('Free Space: ' + data.freeSpaceGB + ' GB');
                                            var totalSpace = data.totalSpaceGB
                                            var usedSpace = data.usedSpaceGB
                                            var freeSpace = data.freeSpaceGB
                                            var os = data.os

                                            totalPerc = Math.round(usedSpace / totalSpace * 100);
                                            var progressBar_<?= $dataSpace['id_ip']; ?> = document.getElementById('progressBar_' + <?= $dataSpace['id_ip']; ?>);

                                            progressBar_<?= $dataSpace['id_ip']; ?>.style.width = totalPerc + '%';

                                            document.getElementById('totalSpace_<?= $dataSpace['id_ip']; ?>').innerHTML = 'Server Storage <b title="' + os + '"><?= $dataSpace['ip_address']; ?></b>, Total Space: <b>' + totalSpace + ' GB</b>';
                                            document.getElementById('usedSpace_<?= $dataSpace['id_ip']; ?>').innerHTML = 'Used Space (' + totalPerc + '%): <b>' + usedSpace + ' GB</b>';
                                            document.getElementById('freeSpace_<?= $dataSpace['id_ip']; ?>').innerHTML = 'Free Space: <b>' + freeSpace + ' GB</b>';

                                            if (totalPerc <= 25) {
                                                warnaPerc = "success"
                                            } else if (totalPerc > 25 && totalPerc <= 50) {
                                                warnaPerc = "primary"
                                            } else if (totalPerc > 50 && totalPerc <= 75) {
                                                warnaPerc = "warning"
                                            } else if (totalPerc > 75 && totalPerc <= 100) {
                                                warnaPerc = "danger"
                                            }
                                            // console.log(warnaPerc)
                                            // <?php $warnaPerch ?> = warnaPerc;
                                            var progressBar = document.getElementById('progressBar_<?= $dataSpace['id_ip']; ?>');
                                            progressBar.classList.add('bg-' + warnaPerc);
                                            var titikBar = document.getElementById('titikBar_<?= $dataSpace['id_ip']; ?>');
                                            titikBar.classList.add('bg-' + warnaPerc);

                                        },
                                        error: function(error) {
                                            console.error('Error:', error);
                                        }
                                    });
                                    // });
                                </script>

                                <div class="col">
                                    <div class="card-body">
                                        <p class="mb-3" id="totalSpace_<?= $dataSpace['id_ip']; ?>"></p>
                                        <div class="progress progress-separated mb-3">
                                            <div class="progress-bar bg- " role="progressbar" aria-label="Total" id="progressBar_<?= $dataSpace['id_ip']; ?>"></div>
                                            <!-- <div class="progress-bar bg-info" role="progressbar" style="width: 25%" aria-label="Used"></div>
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 31%" aria-label="Free"></div> -->
                                        </div>
                                        <div class="row">
                                            <!-- <div class="col-auto d-flex align-items-center pe-2">
                                                <span class="legend me-2 bg-primary"></span>
                                                <span>Total Space: <b></b></span>
                                                -- <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-muted">915MB</span>
                                            </div> -->
                                            <div class="col-auto d-flex align-items-center px-2">
                                                <span class="legend me-2 bg- " id="titikBar_<?= $dataSpace['id_ip']; ?>"></span>
                                                <span id="usedSpace_<?= $dataSpace['id_ip']; ?>"></span>
                                            </div>
                                            <div class="col-auto d-flex align-items-center px-2">
                                                <span class="legend me-2 "></span>
                                                <span id="freeSpace_<?= $dataSpace['id_ip']; ?>"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card " style="height: 30rem">
                    <div class=" card-header">
                        <h3 class="card-title">Database Size</h3>
                    </div>
                    <div class="card-body">
                        <div id="carousel-controls" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php $no = 1;
                                $querySizeDB = mysqli_query($konek, "SELECT * FROM data_ip ORDER BY ip_address DESC");
                                while ($dataSizeDB = mysqli_fetch_assoc($querySizeDB)) { ?>

                                    <script>
                                        $.ajax({
                                            url: 'http://<?= $dataSizeDB['ip_address']; ?>/open_api/size_db.php',
                                            type: 'GET',
                                            dataType: 'json',
                                            success: function(data) {
                                                // Iterasi melalui data dan menampilkan dalam tabel
                                                $.each(data, function(index, item) {
                                                    $('#tbl_<?= $dataSizeDB['id_ip']; ?>').append(
                                                        '<tr>' +
                                                        '<td>' + item.nm_db + '</td>' +
                                                        '<td>' + item.size_db + '</td>' +
                                                        '<td>' + item.size_db_mb + ' MB</td>' +
                                                        '</tr>'
                                                    );
                                                });
                                            },
                                            error: function(error) {
                                                console.log('Error:', error);
                                            }
                                        });
                                    </script>

                                    <div class="carousel-item <?= $no == 1 ? 'active' : ''; ?>">
                                        <div class="card " style="height: 25rem">
                                            <div class="card-header">
                                                <h3 class="card-title">On Server <strong><?= $dataSizeDB['ip_address']; ?></strong></h3>
                                            </div>
                                            <div class="card-body card-body-scrollable card-body-scrollable-shadow">
                                                <div class="divide-y">
                                                    <table class="table card-table table-vcenter" id="tbl_<?= $dataSizeDB['id_ip']; ?>">
                                                        <thead>
                                                            <tr>
                                                                <th>Dabatase Name</th>
                                                                <th>Dabatase Size</th>
                                                                <th>Dabatase Size MiB</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- isi table -->
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="carousel-item">
                                        <img class="d-block w-100" alt="" src="./static/photos/color-palette-guide-sample-colors-catalog-.jpg">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" alt="" src="./static/photos/stylish-workplace-with-computer-at-home.jpg">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" alt="" src="./static/photos/pink-desk-in-the-home-office.jpg">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100" alt="" src="./static/photos/young-woman-sitting-on-the-sofa-and-working-on-her-laptop.jpg">
                                    </div> -->
                                <?php $no++;
                                } ?>
                            </div>
                            <a class="carousel-control-prev" href="#carousel-controls" role="button" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carousel-controls" role="button" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            if ($mon_aktif == "1") { ?>
                <div class="col-lg-12">
                    <div class="col-md-2 col-lg-12">
                        <!-- aria-label -->
                        <label class="card card-sponsor"><?= $hasil_ping; ?></label>
                        <div class="card-body"></div>

                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>