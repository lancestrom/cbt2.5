<div class="container">
    <div class="row">
        <div class="col-md mt-4">
            <div class="card">
                <div class="card-body bg-primary text-white">
                    <h4><?= $siswa['nama_siswa'] ?>
                    </h4>
                    <h4><?= $siswa['kelas'] ?>
                    </h4>

                    <h5>
                        <a class="btn btn-danger btn-sm text-uppercase font-weight-bolder"
                            href="<?= base_url() ?>Dashboard_siswa/logout">Logout</a>
                    </h5>
                </div>
            </div>
        </div>
    </div>


    <div class="row mb-2 mt-2">
        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <!-- <div class="table-responsive">
                            <table class="table table-striped table-bordered text-center text-uppercase font-weight-bolder" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>NAMA MAPEL</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php
                                        $no = 1;
                                        foreach ($ujian as $row) {
                                        ?>
                                            <td class="text-center"><?php echo $no++; ?></td>
                                            <td><?= $row['nama_mapel']; ?></td>
                                            <td>
                                                <h5>
                                                    <a class="btn btn-primary btn-sm" href="<?= base_url() ?>Dashboard_siswa/ujian_siswa/<?= $row['id_jadwal']; ?>">MULAI</a>
                                                </h5>
                                            </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div> -->
                    <div class="row">
                        <?php if (!empty($ujian)): ?>
                            <?php foreach ($ujian as $row): ?>
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div>
                                                <?= htmlspecialchars($row['nama_mapel'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                                                <?php if (!empty($row['durasi'])): ?>
                                                    <div class="small text-muted">Durasi:
                                                        <?= htmlspecialchars($row['durasi'], ENT_QUOTES, 'UTF-8'); ?> menit</div>
                                                <?php endif; ?>
                                            </div>
                                            <div>
                                                <a class="btn btn-primary btn-sm"
                                                    href="<?= base_url('Dashboard_siswa/ujian_siswa/' . $row['id_jadwal']) ?>">MULAI</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12">Tidak ada ujian tersedia.</div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>